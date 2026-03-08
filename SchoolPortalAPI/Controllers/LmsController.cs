using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using SchoolPortalAPI.Data;
using SchoolPortalAPI.Dtos;
using SchoolPortalAPI.Models;

namespace SchoolPortalAPI.Controllers;

[ApiController]
[Route("api/[controller]")]
[Authorize]
public class LmsController(AppDbContext context, IWebHostEnvironment env) : ControllerBase
{
    [HttpGet("courses")]
    public async Task<IActionResult> GetCourses() => Ok(await context.Courses.ToListAsync());

    [HttpPost("courses")]
    [Authorize(Roles = "Admin")]
    public async Task<IActionResult> CreateCourse([FromBody] CourseRequest request)
    {
        var c = new Course { Name = request.Name, Description = request.Description };
        context.Courses.Add(c);
        await context.SaveChangesAsync();
        return Ok(c);
    }

    [HttpGet("subjects")]
    public async Task<IActionResult> GetSubjects() => Ok(await context.Subjects.Include(s => s.Course).Include(s => s.Professor).ToListAsync());

    [HttpPost("subjects")]
    [Authorize(Roles = "Admin")]
    public async Task<IActionResult> CreateSubject([FromBody] SubjectRequest request)
    {
        var s = new Subject { Name = request.Name, CourseId = request.CourseId, ProfessorId = request.ProfessorId };
        context.Subjects.Add(s);
        await context.SaveChangesAsync();
        return Ok(s);
    }

    [HttpPost("enrollments")]
    [Authorize(Roles = "Admin,Student")]
    public async Task<IActionResult> Enroll([FromBody] EnrollmentRequest request)
    {
        if (await context.Enrollments.AnyAsync(e => e.StudentId == request.StudentId && e.SubjectId == request.SubjectId))
            return BadRequest("Student already enrolled in this subject");
        var e = new Enrollment { StudentId = request.StudentId, SubjectId = request.SubjectId, Status = "Enrolled" };
        context.Enrollments.Add(e);
        await context.SaveChangesAsync();
        return Ok(e);
    }

    [HttpGet("enrollments")]
    public async Task<IActionResult> GetEnrollments() => Ok(await context.Enrollments.Include(e => e.Student).Include(e => e.Subject).ToListAsync());

    [HttpPost("exams")]
    [Authorize(Roles = "Professor")]
    public async Task<IActionResult> CreateExam([FromForm] ExamRequest request, IFormFile? file)
    {
        string? path = null;
        if (file is not null)
        {
            var uploads = Path.Combine(env.WebRootPath, "uploads");
            Directory.CreateDirectory(uploads);
            var fileName = $"exam_{Guid.NewGuid()}{Path.GetExtension(file.FileName)}";
            var fullPath = Path.Combine(uploads, fileName);
            await using var stream = System.IO.File.Create(fullPath);
            await file.CopyToAsync(stream);
            path = $"/uploads/{fileName}";
        }

        var exam = new Exam { SubjectId = request.SubjectId, Title = request.Title, ScheduleAt = request.ScheduleAt, FilePath = path };
        context.Exams.Add(exam);
        await context.SaveChangesAsync();
        return Ok(exam);
    }

    [HttpGet("exams")]
    public async Task<IActionResult> GetExams() => Ok(await context.Exams.Include(e => e.Subject).ToListAsync());

    [HttpPost("grades")]
    [Authorize(Roles = "Professor")]
    public async Task<IActionResult> SaveGrade([FromBody] GradeRequest request)
    {
        var grade = new Grade { ExamId = request.ExamId, StudentId = request.StudentId, Score = request.Score, MaxScore = request.MaxScore };
        context.Grades.Add(grade);
        await context.SaveChangesAsync();
        return Ok(grade);
    }

    [HttpGet("grades")]
    public async Task<IActionResult> GetGrades()
    {
        var role = User.FindFirst("http://schemas.microsoft.com/ws/2008/06/identity/claims/role")?.Value;
        var userId = int.Parse(User.FindFirst("sub")!.Value);
        if (role == "Student")
            return Ok(await context.Grades.Include(g => g.Exam).Where(g => g.StudentId == userId).ToListAsync());
        return Ok(await context.Grades.Include(g => g.Exam).Include(g => g.Student).ToListAsync());
    }
}
