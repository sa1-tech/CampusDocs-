package com.campusdocs.activities;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.campusdocs.R;
import com.campusdocs.adapters.SubjectAdapter;
import com.campusdocs.models.Subject;
import com.campusdocs.network.ApiClient;
import com.campusdocs.network.ApiService;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SubjectActivity extends AppCompatActivity {

	private static final String TAG = "SubjectActivity";

	private TextView courseSemesterTitle;
	private ListView subjectListView;
	private SubjectAdapter subjectAdapter;

	private int semesterId, courseId;
	private String courseTitle, semesterTitle;

	private ApiService apiService;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_subject);

		courseSemesterTitle = findViewById(R.id.courseSemesterTitle);
		subjectListView = findViewById(R.id.subjectListView);

		// ✅ Correctly initialize both IDs from intent
		courseId = Integer.parseInt(getIntent().getStringExtra("course_id"));
		semesterId = Integer.parseInt(getIntent().getStringExtra("semester_id"));
		courseTitle = getIntent().getStringExtra("course_title");
		semesterTitle = getIntent().getStringExtra("semester_title");

		courseSemesterTitle.setText(courseTitle + " - " + semesterTitle);

		apiService = ApiClient.getRetrofitInstance().create(ApiService.class);

		fetchSubjects(courseId, semesterId);
	}

	private void fetchSubjects(int courseId, int semesterId) {
		Log.d(TAG, "Fetching subjects for Course ID: " + courseId + ", Semester ID: " + semesterId);

		apiService.getSubjects(courseId, semesterId).enqueue(new Callback<List<Subject>>() {
			@Override
			public void onResponse(Call<List<Subject>> call, Response<List<Subject>> response) {
				if (response.isSuccessful() && response.body() != null && !response.body().isEmpty()) {
					subjectAdapter = new SubjectAdapter(SubjectActivity.this, R.layout.item_subject, response.body());
					subjectListView.setAdapter(subjectAdapter);

					subjectListView.setOnItemClickListener((adapterView, view, position, id) -> {
						Subject selectedSubject = response.body().get(position);
						Intent intent = new Intent(SubjectActivity.this, UnitActivity.class);
						intent.putExtra("subject_id", selectedSubject.getId());
						intent.putExtra("subject_name", selectedSubject.getName());
						startActivity(intent);
					});
				} else {
					Toast.makeText(SubjectActivity.this, "No subjects found", Toast.LENGTH_SHORT).show();
				}
			}

			@Override
			public void onFailure(Call<List<Subject>> call, Throwable t) {
				Toast.makeText(SubjectActivity.this, "Failed to fetch subjects", Toast.LENGTH_SHORT).show();
				Log.e(TAG, "Error: " + t.getMessage(), t);
			}
		});
	}
}
