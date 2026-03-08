using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using SchoolPortalAPI.Data;
using SchoolPortalAPI.Dtos;
using SchoolPortalAPI.Services;

namespace SchoolPortalAPI.Controllers;

[ApiController]
[Route("api/[controller]")]
public class AuthController(AppDbContext context, TokenService tokenService) : ControllerBase
{
    [HttpPost("login")]
    public async Task<ActionResult<LoginResponse>> Login([FromBody] LoginRequest request)
    {
        var user = await context.Users.Include(u => u.Role)
            .FirstOrDefaultAsync(u => u.Username == request.Username);

        if (user is null || user.Role is null)
        {
            return Unauthorized("Invalid username or password");
        }

        var validPassword = BCrypt.Net.BCrypt.Verify(request.Password, user.PasswordHash) || user.PasswordHash == request.Password;
        if (!validPassword)
        {
            return Unauthorized("Invalid username or password");
        }

        var token = tokenService.CreateToken(user, user.Role.Name);
        return Ok(new LoginResponse(token, user.Username, user.Role.Name, user.Id, user.FullName));
    }
}
