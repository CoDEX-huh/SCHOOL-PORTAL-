using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using SchoolPortalAPI.Data;
using SchoolPortalAPI.Dtos;
using SchoolPortalAPI.Models;
using ModelClaim = SchoolPortalAPI.Models.Claim;

namespace SchoolPortalAPI.Controllers;

[ApiController]
[Route("api/[controller]")]
[Authorize]
public class LostFoundController(AppDbContext context, IWebHostEnvironment env) : ControllerBase
{
    [HttpPost("lost")]
    public async Task<IActionResult> ReportLost([FromForm] LostFoundRequest request, IFormFile? image)
    {
        var userId = int.Parse(User.FindFirst("sub")!.Value);
        var item = new LostItem { ReporterId = userId, ItemDetails = request.ItemDetails, Location = request.Location };
        item.ImagePath = await SaveImage(image);
        context.LostItems.Add(item);
        await context.SaveChangesAsync();
        return Ok(item);
    }

    [HttpPost("found")]
    public async Task<IActionResult> ReportFound([FromForm] LostFoundRequest request, IFormFile? image)
    {
        var userId = int.Parse(User.FindFirst("sub")!.Value);
        var item = new FoundItem { ReporterId = userId, ItemDetails = request.ItemDetails, Location = request.Location };
        item.ImagePath = await SaveImage(image);
        context.FoundItems.Add(item);
        await context.SaveChangesAsync();
        return Ok(item);
    }

    [HttpGet("lost")]
    public async Task<IActionResult> GetLost() => Ok(await context.LostItems.ToListAsync());

    [HttpGet("found")]
    public async Task<IActionResult> GetFound() => Ok(await context.FoundItems.ToListAsync());

    [HttpPost("claims")]
    [Authorize(Roles = "Student")]
    public async Task<IActionResult> CreateClaim([FromBody] ClaimRequest request)
    {
        var userId = int.Parse(User.FindFirst("sub")!.Value);
        var claim = new ModelClaim
        {
            StudentId = userId,
            LostItemId = request.LostItemId,
            FoundItemId = request.FoundItemId,
            OwnershipVerification = request.OwnershipVerification,
            Status = "Pending"
        };
        context.Claims.Add(claim);
        await context.SaveChangesAsync();
        return Ok(claim);
    }

    [HttpPut("claims/{id}/status")]
    [Authorize(Roles = "Admin")]
    public async Task<IActionResult> UpdateClaimStatus(int id, [FromBody] ClaimStatusRequest request)
    {
        var claim = await context.Claims.FindAsync(id);
        if (claim is null) return NotFound();
        claim.Status = request.Status;
        await context.SaveChangesAsync();
        return Ok(claim);
    }

    [HttpGet("claims")]
    public async Task<IActionResult> GetClaims() => Ok(await context.Claims.Include(c => c.Student).Include(c => c.LostItem).Include(c => c.FoundItem).ToListAsync());

    [HttpGet("announcements")]
    [AllowAnonymous]
    public async Task<IActionResult> GetAnnouncements() => Ok(await context.Announcements.OrderByDescending(a => a.PublishAt).ToListAsync());

    private async Task<string?> SaveImage(IFormFile? image)
    {
        if (image is null) return null;
        var uploads = Path.Combine(env.WebRootPath, "uploads");
        Directory.CreateDirectory(uploads);
        var fileName = $"item_{Guid.NewGuid()}{Path.GetExtension(image.FileName)}";
        var fullPath = Path.Combine(uploads, fileName);
        await using var stream = System.IO.File.Create(fullPath);
        await image.CopyToAsync(stream);
        return $"/uploads/{fileName}";
    }
}
