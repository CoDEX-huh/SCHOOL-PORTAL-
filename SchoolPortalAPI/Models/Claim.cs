namespace SchoolPortalAPI.Models;

public class Claim
{
    public int Id { get; set; }
    public int StudentId { get; set; }
    public User? Student { get; set; }
    public int? LostItemId { get; set; }
    public LostItem? LostItem { get; set; }
    public int? FoundItemId { get; set; }
    public FoundItem? FoundItem { get; set; }
    public string OwnershipVerification { get; set; } = string.Empty;
    public string Status { get; set; } = "Pending";
    public DateTime ClaimAt { get; set; } = DateTime.UtcNow;
}
