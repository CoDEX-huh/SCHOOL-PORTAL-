using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using SchoolPortalAPI.Data;
using SchoolPortalAPI.Dtos;
using SchoolPortalAPI.Models;

namespace SchoolPortalAPI.Controllers;

[ApiController]
[Route("api/[controller]")]
[Authorize(Roles = "Admin")]
public class AdminController(AppDbContext context) : ControllerBase
{
    [HttpGet("users")]
    public async Task<IActionResult> GetUsers() => Ok(await context.Users.Include(u => u.Role).ToListAsync());

    [HttpPost("users")]
    public async Task<IActionResult> CreateUser([FromBody] UserCreateRequest request)
    {
        if (await context.Users.AnyAsync(u => u.Username == request.Username))
            return BadRequest("Username already exists");

        var user = new User
        {
            Username = request.Username,
            PasswordHash = BCrypt.Net.BCrypt.HashPassword(request.Password),
            FullName = request.FullName,
            RoleId = request.RoleId
        };

        context.Users.Add(user);
        await context.SaveChangesAsync();
        return Ok(user);
    }

    [HttpGet("roles")]
    public async Task<IActionResult> GetRoles() => Ok(await context.Roles.ToListAsync());

    [HttpPost("announcements")]
    public async Task<IActionResult> CreateAnnouncement([FromBody] AnnouncementRequest request)
    {
        var userId = int.Parse(User.FindFirst("sub")!.Value);
        var a = new Announcement { Title = request.Title, Content = request.Content, PostedById = userId };
        context.Announcements.Add(a);
        await context.SaveChangesAsync();
        return Ok(a);
    }
}
