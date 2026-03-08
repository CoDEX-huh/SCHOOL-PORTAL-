namespace SchoolPortalAPI.Models;

public class Announcement
{
    public int Id { get; set; }
    public string Title { get; set; } = string.Empty;
    public string Content { get; set; } = string.Empty;
    public int PostedById { get; set; }
    public User? PostedBy { get; set; }
    public DateTime PublishAt { get; set; } = DateTime.UtcNow;
}
