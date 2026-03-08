namespace SchoolPortalAPI.Dtos;

public record CourseRequest(string Name, string Description);
public record SubjectRequest(string Name, int CourseId, int? ProfessorId);
public record EnrollmentRequest(int StudentId, int SubjectId);
public record ExamRequest(int SubjectId, string Title, DateTime ScheduleAt);
public record GradeRequest(int ExamId, int StudentId, decimal Score, decimal MaxScore);
