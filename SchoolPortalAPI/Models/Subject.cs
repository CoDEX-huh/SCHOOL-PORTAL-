namespace SchoolPortalAPI.Models;

public class Subject
{
    public int Id { get; set; }
    public string Name { get; set; } = string.Empty;
    public int CourseId { get; set; }
    public Course? Course { get; set; }
    public int? ProfessorId { get; set; }
    public User? Professor { get; set; }
}
