# LMS Application Testing Guide

## 🚀 Application URL
**Local Server**: http://localhost:8080

## 📋 Test Credentials
- **Admin**: admin@example.com / admin
- **Teacher**: teacher@example.com / admin  
- **Student**: student@example.com / admin

## 🧪 Testing Steps

### Step 1: Admin/Instructor Login and File Upload

1. **Navigate to**: http://localhost:8080
2. **Click**: "Login" button
3. **Login as Teacher**: 
   - Email: teacher@example.com
   - Password: admin
4. **Verify**: Dashboard shows teacher interface
5. **Navigate to Course Materials**:
   - Go to: http://localhost:8080/materials/list/1
   - Or click "Materials" button from dashboard
6. **Upload a File**:
   - Click "Upload New Material" button
   - Select a PDF or PPT file
   - Click "Upload Material"
7. **Verify**: Success message appears

### Step 2: Verify Database Record

Check the database to ensure:
- File is saved in `writable/uploads/materials/` folder
- Record is added to `materials` table

### Step 3: Test Student Access

1. **Logout** from teacher account
2. **Login as Student**:
   - Email: student@example.com
   - Password: admin
3. **Navigate to Dashboard**
4. **Click "Materials"** button for enrolled course
5. **Verify**: Material is listed with download button

### Step 4: Test Download Functionality

1. **Click "Download"** button on the material
2. **Verify**: File downloads successfully
3. **Check**: Downloaded file has correct name and content

### Step 5: Test Access Restrictions

1. **Try accessing**: http://localhost:8080/materials/download/1
2. **Without login**: Should redirect to login page
3. **With different user**: Should show permission error

## 🔍 Expected Results

### ✅ Success Indicators:
- File uploads successfully
- Database record created
- Student can see materials
- Download works correctly
- Access restrictions enforced

### ❌ Failure Indicators:
- Upload errors
- Database not updated
- Students can't see materials
- Download fails
- Unauthorized access allowed

## 🛠️ Troubleshooting

### Common Issues:
1. **File Upload Fails**: Check file size and type
2. **Database Error**: Verify database connection
3. **Permission Denied**: Check user roles and enrollment
4. **File Not Found**: Verify file path and permissions

### Debug Commands:
```bash
# Check database
mysql -u root -e "USE lms_pecayo; SELECT * FROM materials;"

# Check file permissions
ls -la writable/uploads/materials/

# Check logs
tail -f writable/logs/log-*.php
```
