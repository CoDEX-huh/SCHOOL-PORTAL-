using Microsoft.EntityFrameworkCore;
using SchoolPortalAPI.Models;

namespace SchoolPortalAPI.Data;

public class AppDbContext(DbContextOptions<AppDbContext> options) : DbContext(options)
{
    public DbSet<Role> Roles => Set<Role>();
    public DbSet<User> Users => Set<User>();
    public DbSet<Course> Courses => Set<Course>();
    public DbSet<Subject> Subjects => Set<Subject>();
    public DbSet<Enrollment> Enrollments => Set<Enrollment>();
    public DbSet<Exam> Exams => Set<Exam>();
    public DbSet<Grade> Grades => Set<Grade>();
    public DbSet<LostItem> LostItems => Set<LostItem>();
    public DbSet<FoundItem> FoundItems => Set<FoundItem>();
    public DbSet<Claim> Claims => Set<Claim>();
    public DbSet<Announcement> Announcements => Set<Announcement>();

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        modelBuilder.Entity<Role>().ToTable("roles");
        modelBuilder.Entity<User>().ToTable("users");
        modelBuilder.Entity<Course>().ToTable("courses");
        modelBuilder.Entity<Subject>().ToTable("subjects");
        modelBuilder.Entity<Enrollment>().ToTable("enrollments");
        modelBuilder.Entity<Exam>().ToTable("exams");
        modelBuilder.Entity<Grade>().ToTable("grades");
        modelBuilder.Entity<LostItem>().ToTable("lost_items");
        modelBuilder.Entity<FoundItem>().ToTable("found_items");
        modelBuilder.Entity<Claim>().ToTable("claims");
        modelBuilder.Entity<Announcement>().ToTable("announcements");

        modelBuilder.Entity<User>()
            .HasIndex(u => u.Username)
            .IsUnique();

        modelBuilder.Entity<Subject>()
            .HasOne(s => s.Professor)
            .WithMany()
            .HasForeignKey(s => s.ProfessorId)
            .OnDelete(DeleteBehavior.SetNull);

        modelBuilder.Entity<Claim>()
            .HasOne(c => c.LostItem)
            .WithMany()
            .HasForeignKey(c => c.LostItemId)
            .OnDelete(DeleteBehavior.SetNull);

        modelBuilder.Entity<Claim>()
            .HasOne(c => c.FoundItem)
            .WithMany()
            .HasForeignKey(c => c.FoundItemId)
            .OnDelete(DeleteBehavior.SetNull);
    }
}
