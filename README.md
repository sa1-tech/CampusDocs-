# 🎓 CampusDocs – Smart Academic Document Manager

Welcome to **CampusDocs**, a smart document management platform designed to streamline academic material distribution with:

- 🔐 A secure **Admin Panel** for managing courses, semesters, subjects, and units
- 📲 A user-friendly **Student App** for accessing categorized learning materials (PDFs)
- 📚 Real-time course data, visual analytics, and secure access flow

Developed by **Savan**, CampusDocs is your one-stop academic companion.
https://youtu.be/XtiNK83ySA4?si=kCz3E5D70HQKxz7M
---

## 👨‍💼 Admin Panel Features

> The admin dashboard is the central hub for managing academic data.

### 🔐 Login System
- Admin credentials stored in the `users` table (Role: `admin`)
- Passwords are stored securely using **MD5 encryption**
- Login via the index page with email + password

### 📊 Dashboard Overview
- Displays total counts:
  - Courses
  - Semesters
  - Subjects
  - Users
- Includes a **Pie Chart** for visual distribution
- Built-in **search bar** to find any uploaded PDF instantly

### 🏫 Course Management
- Add new courses
- Edit existing course names
- Delete any course
- Changes update the `courses` table in real-time

### 📆 Semester Management
- Add semesters to any course
- Edit or remove them as needed
- Data synced with the `semesters` table

### 📚 Subject Management
- Select course + semester to assign a subject
- Subjects are stored in the `subjects` table
- Real-time dynamic linking

### 📁 PDF & Unit Management
- Select subject → Enter unit name → Attach one or more PDFs
- Click **Add Unit** to save it in the database
- Materials are instantly available in the student app

### 🔓 Admin Logout
- Secure logout button in the top bar
- Ends session and returns to login screen

---

## 📲 Student App Features

> Designed for fast and structured access to study materials.

### ✨ Splash Screen
- Displays CampusDocs logo and branding

### 📝 Registration & Login
- New users register with:
  - Name, Email, Password, etc.
- Login using registered credentials

### 🧭 App Navigation Flow
1. User sees available **Courses**
2. Select a course → Choose a **Semester**
3. Semester opens list of **Subjects**
4. Tap subject → See list of **Units** and attached **PDFs**

### 📖 View PDFs
- Tapping a PDF opens it using:
  - External viewer OR
  - Default browser (based on device capabilities)

---

## 🚀 Highlights

- ✅ Dynamic PDF uploading and linking to subjects/units
- ✅ Category-based browsing experience
- ✅ Pie chart analytics for quick admin insights
- ✅ Real-time database integration
- ✅ Smooth and intuitive UI/UX for both admin and student users

---

## 🛠 Tech Stack

| Component        | Technology Used            |
|------------------|----------------------------|
| Backend (Admin)  | PHP + MySQL                |
| Frontend (Admin) | HTML, CSS, JS / Bootstrap  |
| Mobile App       | Java (Android Studio)      |
| Authentication   | PHP Sessions + MD5 Hashing |
| File Storage     | Local Server + DB records  |

---

## 🙋‍♂️ Author

Developed by **Savan**  
📺 YouTube: [Apps by Savan](https://www.youtube.com/@techsa1-goswami)

> 💬 “CampusDocs brings academic clarity to the digital age — helping admins manage and students learn smarter.”


## ✅ Want to Contribute?

- Star 🌟 the repo
- Fork 🍴 and customize it for your campus or institution
- Pull requests are welcome!

---

### 💡 Future Improvements (Ideas)
- 🔍 In-app PDF viewer
- 🔐 JWT or OAuth-based secure login
- ☁️ Firebase or cloud storage integration
- 📥 Download PDF support in app


