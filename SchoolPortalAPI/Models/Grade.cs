namespace SchoolPortalAPI.Models;

public class Grade
{
    public int Id { get; set; }
    public int ExamId { get; set; }
    public Exam? Exam { get; set; }
    public int StudentId { get; set; }
    public User? Student { get; set; }
    public decimal Score { get; set; }
    public decimal MaxScore { get; set; } = 100;
}
