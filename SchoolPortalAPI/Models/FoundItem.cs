namespace SchoolPortalAPI.Models;

public class FoundItem
{
    public int Id { get; set; }
    public int ReporterId { get; set; }
    public User? Reporter { get; set; }
    public string ItemDetails { get; set; } = string.Empty;
    public string? ImagePath { get; set; }
    public string Location { get; set; } = string.Empty;
    public DateTime ReportedAt { get; set; } = DateTime.UtcNow;
}
