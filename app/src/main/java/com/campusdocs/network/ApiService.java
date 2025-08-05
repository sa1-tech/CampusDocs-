package com.campusdocs.network;

import com.campusdocs.models.Course;
import com.campusdocs.models.LoginRequest;
import com.campusdocs.models.LoginResponse;
import com.campusdocs.models.PdfResponse;
import com.campusdocs.models.RegisterRequest;
import com.campusdocs.models.Semester;
import com.campusdocs.models.Subject;
import com.campusdocs.models.Unit;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Query;

public interface ApiService {

	@POST("register.php")
	Call<LoginResponse> registerUser(@Body RegisterRequest registerRequest);

	@POST("login.php")
	Call<LoginResponse> loginUser(@Body LoginRequest loginRequest);

	@GET("get_courses.php")
	Call<List<Course>> getCourses();

	@GET("get_semesters.php")
	Call<List<Semester>> getSemesters(
			@Query("course_id") int courseId
	);

	@GET("get_subjects.php")
	Call<List<Subject>> getSubjects(
			@Query("course_id") int courseId,
			@Query("semester_id") int semesterId
	);

	@GET("get_units.php")
	Call<List<Unit>> getUnits(
			@Query("subject_id") int subjectId
	);

	@GET("get_unit_pdf.php")
	Call<PdfResponse> getPdfUrl(
			@Query("unit_id") int unitId
	);

}
