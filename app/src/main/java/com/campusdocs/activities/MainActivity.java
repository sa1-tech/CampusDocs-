package com.campusdocs.activities;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Spinner;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.campusdocs.R;
import com.campusdocs.adapters.CourseAdapter;
import com.campusdocs.adapters.SemesterAdapter;
import com.campusdocs.models.Course;
import com.campusdocs.models.Semester;
import com.campusdocs.network.ApiClient;
import com.campusdocs.network.ApiService;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity implements CourseAdapter.OnCourseClickListener {

	private static final String TAG = "MainActivity";
	private RecyclerView recyclerView;
	private CourseAdapter courseAdapter;
	private List<Course> courseList = new ArrayList<>();
	private ApiService apiService;

	private Spinner semesterSpinner;
	private View semesterLayout;
	private String selectedCourseId = "";
	private String selectedCourseTitle = "";

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		setTitle("CampusDocs");

		Log.d(TAG, "onCreate: Initializing views");

		recyclerView = findViewById(R.id.recyclerCourses);
		semesterSpinner = findViewById(R.id.spinnerSemester);
		semesterLayout = findViewById(R.id.semesterLayout);

		recyclerView.setLayoutManager(new LinearLayoutManager(this));
		courseAdapter = new CourseAdapter(courseList, this);
		recyclerView.setAdapter(courseAdapter);

		apiService = ApiClient.getRetrofitInstance().create(ApiService.class);
		fetchCourses();
	}

	private void fetchCourses() {
		Log.d(TAG, "fetchCourses: Fetching course list from API...");

		apiService.getCourses().enqueue(new Callback<List<Course>>() {
			@Override
			public void onResponse(Call<List<Course>> call, Response<List<Course>> response) {
				if (response.isSuccessful() && response.body() != null) {
					courseList.clear();
					courseList.addAll(response.body());
					courseAdapter.notifyDataSetChanged();

					Log.d(TAG, "onResponse: Courses loaded - " + courseList.size());
				} else {
					Log.e(TAG, "onResponse: Failed to load courses");
					Toast.makeText(MainActivity.this, "Failed to load courses", Toast.LENGTH_SHORT).show();
				}
			}

			@Override
			public void onFailure(Call<List<Course>> call, Throwable t) {
				Log.e(TAG, "onFailure: Error loading courses - " + t.getMessage());
				Toast.makeText(MainActivity.this, "Error: " + t.getMessage(), Toast.LENGTH_SHORT).show();
			}
		});
	}

	@Override
	public void onCourseClick(Course course) {
		selectedCourseId = String.valueOf(course.getId());
		selectedCourseTitle = course.getName();

		Log.d(TAG, "onCourseClick: Selected course - " + selectedCourseTitle + " (ID: " + selectedCourseId + ")");

		apiService.getSemesters(course.getId()).enqueue(new Callback<List<Semester>>() {
			@Override
			public void onResponse(Call<List<Semester>> call, Response<List<Semester>> response) {
				if (response.isSuccessful() && response.body() != null && !response.body().isEmpty()) {
					Log.d(TAG, "onResponse: Semesters loaded for course " + selectedCourseId);
					loadSemesterDropdown(response.body());
				} else {
					Log.w(TAG, "onResponse: No semesters available for course " + selectedCourseId);
					Toast.makeText(MainActivity.this, "No semesters available for this course", Toast.LENGTH_SHORT).show();
				}
			}

			@Override
			public void onFailure(Call<List<Semester>> call, Throwable t) {
				Log.e(TAG, "onFailure: Error loading semesters - " + t.getMessage());
				Toast.makeText(MainActivity.this, "Error loading semesters: " + t.getMessage(), Toast.LENGTH_SHORT).show();
			}
		});
	}

	private void loadSemesterDropdown(List<Semester> semesters) {
		semesterLayout.setVisibility(View.VISIBLE);
		Log.d(TAG, "loadSemesterDropdown: Showing semester spinner with " + semesters.size() + " items");

		// Insert default item
		Semester defaultItem = new Semester();
		defaultItem.setId(-1);
		defaultItem.setName("Select Semester");
		semesters.add(0, defaultItem);

		SemesterAdapter semesterAdapter = new SemesterAdapter(this, R.layout.item_semester, semesters);
		semesterSpinner.setAdapter(semesterAdapter);

		semesterSpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
			@Override
			public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
				Semester selectedSemester = (Semester) parent.getItemAtPosition(position);

				if (selectedSemester.getId() == -1) {
					Log.d(TAG, "onItemSelected: Default semester selected. Waiting for user input.");
					return;
				}

				Log.d(TAG, "onItemSelected: Semester selected - " + selectedSemester.getName() + " (ID: " + selectedSemester.getId() + ")");

				Intent intent = new Intent(MainActivity.this, SubjectActivity.class);
				intent.putExtra("course_id", selectedCourseId);
				intent.putExtra("course_title", selectedCourseTitle);
				intent.putExtra("semester_id", String.valueOf(selectedSemester.getId()));
				intent.putExtra("semester_title", selectedSemester.getName());

				Log.d(TAG, "Navigating to SubjectActivity with course and semester info");
				startActivity(intent);
			}

			@Override
			public void onNothingSelected(AdapterView<?> parent) {
				Log.d(TAG, "onNothingSelected: No semester selected");
			}
		});
	}
}
