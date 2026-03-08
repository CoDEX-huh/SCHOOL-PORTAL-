namespace SchoolPortalAPI.Models;

public class Exam
{
    public int Id { get; set; }
    public int SubjectId { get; set; }
    public Subject? Subject { get; set; }
    public string Title { get; set; } = string.Empty;
    public string? FilePath { get; set; }
    public DateTime ScheduleAt { get; set; }
}
