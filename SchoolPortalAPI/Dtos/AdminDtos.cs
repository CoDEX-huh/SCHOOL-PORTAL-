namespace SchoolPortalAPI.Dtos;

public record UserCreateRequest(string Username, string Password, string FullName, int RoleId);
public record AnnouncementRequest(string Title, string Content);
