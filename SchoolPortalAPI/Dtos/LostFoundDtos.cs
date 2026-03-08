namespace SchoolPortalAPI.Dtos;

public record LostFoundRequest(string ItemDetails, string Location);
public record ClaimRequest(int? LostItemId, int? FoundItemId, string OwnershipVerification);
public record ClaimStatusRequest(string Status);
