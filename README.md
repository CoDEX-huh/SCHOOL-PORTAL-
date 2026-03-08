# SchoolPortal

## 1. Install Requirements
- .NET 8 SDK
- XAMPP

## 2. Start XAMPP
- Start Apache
- Start MySQL

## 3. Import Database
- Open http://localhost/phpmyadmin
- Import `Database/init.sql`

## 4. Run API
Open terminal:

```bash
cd SchoolPortalAPI
dotnet restore
dotnet run
```

API will run at:
`http://localhost:5090`

## 5. Run Frontend
Move `Frontend` folder to:
`C:\xampp\htdocs\schoolportal`

## 6. Open Browser
`http://localhost/schoolportal/login.php`

## 7. Demo Login
Admin
- `admin / Admin@123`

Professor
- `prof1 / Prof@123`

Student
- `stud1 / Stud@123`
