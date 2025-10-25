# 🎓 Admin Course Management System

## 🚀 **Overview**
The Admin Course Management System allows administrators to upload and manage course materials for all courses in the LMS. Students can then view and download materials from their enrolled courses.

## 🔗 **Access URLs**

### **Primary Access Points:**
- **Admin Dashboard**: http://localhost:8080/dashboard
- **Course Management**: http://localhost:8080/admin/course-management
- **Direct Upload**: http://localhost:8080/materials/upload/{course_id}
- **View Materials**: http://localhost:8080/materials/list/{course_id}

## 👤 **Test Credentials**
- **Admin**: admin@example.com / admin
- **Teacher**: teacher@example.com / admin
- **Student**: student@example.com / admin

## 🧪 **Complete Testing Flow**

### **Phase 1: Admin Access and Course Management**

1. **Login as Admin**:
   - Go to: http://localhost:8080
   - Login with: admin@example.com / admin
   - Verify: Admin dashboard loads with course management section

2. **Access Course Management**:
   - Click "Manage Course Materials" button on dashboard
   - Or go directly to: http://localhost:8080/admin/course-management
   - Verify: Course management interface loads with all courses

3. **Explore Course Cards**:
   - Each course shows: Title, Instructor, Materials Count, Creation Date
   - Two action buttons: "View Materials" and "Upload"
   - Color-coded left border for visual distinction

### **Phase 2: Upload Materials to Courses**

1. **Upload to Course 1**:
   - Click "Upload" button on any course card
   - Or go to: http://localhost:8080/materials/upload/1
   - Upload the test file: `test_material.pdf`
   - Verify: Success message appears

2. **Upload to Multiple Courses**:
   - Upload different files to different courses
   - Test various file types: PDF, DOC, PPT, images
   - Verify: Each upload creates database record

3. **Verify Database Records**:
   ```bash
   C:\xampp\mysql\bin\mysql.exe -u root -e "USE lms_pecayo; SELECT * FROM materials;"
   ```

### **Phase 3: Student Access and Download**

1. **Login as Student**:
   - Logout from admin account
   - Login with: student@example.com / admin
   - Verify: Student dashboard shows enrolled courses

2. **Access Course Materials**:
   - Click "Materials" button for enrolled course
   - Or go to: http://localhost:8080/materials/list/1
   - Verify: Uploaded materials are visible

3. **Download Materials**:
   - Click "Download" button on any material
   - Verify: File downloads successfully
   - Check: Downloaded file has correct name and content

### **Phase 4: Access Control Testing**

1. **Unauthorized Access**:
   - Try accessing: http://localhost:8080/admin/course-management
   - Without login: Should redirect to login page
   - With student account: Should show access denied

2. **Cross-Course Access**:
   - Login as student
   - Try accessing materials from non-enrolled course
   - Verify: Access denied or empty materials list

## 🎨 **Interface Features**

### **Course Management Page:**
- **Header**: Instagram-style gradient with title and description
- **Course Cards**: Grid layout with color-coded borders
- **Course Information**: Title, instructor, materials count, creation date
- **Action Buttons**: View Materials (blue) and Upload (green)
- **Responsive Design**: Works on all device sizes
- **Empty State**: Friendly message when no courses exist

### **Admin Dashboard Integration:**
- **Course Management Section**: Quick overview of courses
- **Materials Count**: Shows materials count for each course
- **Quick Upload**: Direct upload buttons for first 3 courses
- **Management Button**: Link to full course management page

## 🔒 **Security Features**

### **Access Control:**
- **Admin Only**: Course management restricted to admin users
- **Role Verification**: Checks user role before allowing access
- **Session Validation**: Ensures user is logged in
- **Redirect Protection**: Unauthorized users redirected appropriately

### **File Security:**
- **Path Validation**: Files restricted to upload directory
- **File Type Validation**: Only allowed file types accepted
- **Size Limits**: Maximum file size enforced
- **Unique Names**: Files renamed to prevent conflicts

## 📊 **Database Integration**

### **Tables Used:**
- **courses**: Course information and instructor details
- **materials**: File metadata and storage paths
- **users**: User roles and permissions
- **enrollments**: Student course enrollments

### **Key Queries:**
- **Course List**: Gets all courses with instructor names
- **Materials Count**: Calculates materials per course
- **Enrollment Check**: Verifies student enrollment
- **File Metadata**: Stores file information securely

## 🛠️ **Troubleshooting**

### **Common Issues:**

1. **Access Denied**:
   - Ensure logged in as admin
   - Check user role in database
   - Verify session is active

2. **Upload Fails**:
   - Check file size (max 10MB)
   - Verify file type is allowed
   - Ensure writable directory permissions

3. **Materials Not Visible**:
   - Check student enrollment
   - Verify course ID matches
   - Check database records

### **Debug Commands:**
```bash
# Check database
mysql -u root -e "USE lms_pecayo; SELECT * FROM materials;"

# Check upload directory
dir writable\uploads\materials

# Check logs
type writable\logs\*.log
```

## 🎯 **Expected Results**

### ✅ **Success Indicators:**
- Admin can access course management interface
- Course cards display with correct information
- File uploads work for all supported types
- Database records created correctly
- Students can view and download materials
- Access restrictions work properly
- Interface is responsive and user-friendly

### 📈 **Performance Features:**
- Fast page loading with optimized queries
- Efficient file handling and storage
- Responsive design for all devices
- Clean, modern interface design
- Proper error handling and user feedback

## 🚀 **Next Steps**

1. **Test Complete Flow**: Follow all testing phases
2. **Upload Various Files**: Test different file types and sizes
3. **Verify Student Access**: Ensure students can download materials
4. **Check Access Control**: Verify security restrictions work
5. **Test Responsive Design**: Check on different screen sizes

The Admin Course Management System is now fully functional and ready for comprehensive testing! 🎉
