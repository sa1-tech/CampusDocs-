package com.campusdocs.activities;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.campusdocs.R;
import com.campusdocs.adapters.UnitAdapter;
import com.campusdocs.models.Unit;
import com.campusdocs.network.ApiClient;
import com.campusdocs.network.ApiService;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class UnitActivity extends AppCompatActivity implements UnitAdapter.OnUnitClickListener {

	private static final String TAG = "UnitActivity";

	private RecyclerView unitRecyclerView;
	private UnitAdapter unitAdapter;
	private TextView subjectTitle;

	private int subjectId;
	private String subjectName;

	private ApiService apiService;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_unit);

		subjectTitle = findViewById(R.id.subjectTitle);
		unitRecyclerView = findViewById(R.id.unitRecyclerView);

		// Get intent data
		subjectId = getIntent().getIntExtra("subject_id", -1);
		subjectName = getIntent().getStringExtra("subject_name");

		if (subjectId == -1 || subjectName == null) {
			Toast.makeText(this, "Invalid subject data", Toast.LENGTH_SHORT).show();
			finish();
			return;
		}

		subjectTitle.setText(subjectName);

		apiService = ApiClient.getRetrofitInstance().create(ApiService.class);

		fetchUnits(subjectId);
	}

	private void fetchUnits(int subjectId) {
		Log.d(TAG, "Fetching units for subject ID: " + subjectId);

		apiService.getUnits(subjectId).enqueue(new Callback<List<Unit>>() {
			@Override
			public void onResponse(Call<List<Unit>> call, Response<List<Unit>> response) {
				if (response.isSuccessful() && response.body() != null && !response.body().isEmpty()) {
					unitAdapter = new UnitAdapter(response.body(), UnitActivity.this);
					unitRecyclerView.setLayoutManager(new LinearLayoutManager(UnitActivity.this));
					unitRecyclerView.setAdapter(unitAdapter);
				} else {
					Toast.makeText(UnitActivity.this, "No units found", Toast.LENGTH_SHORT).show();
				}
			}

			@Override
			public void onFailure(Call<List<Unit>> call, Throwable t) {
				Log.e(TAG, "Error fetching units: " + t.getMessage(), t);
				Toast.makeText(UnitActivity.this, "Failed to fetch units", Toast.LENGTH_SHORT).show();
			}
		});
	}

	@Override
	public void onUnitClick(Unit unit) {
		if (unit == null) {
			Log.e("UnitClick", "Clicked unit is null");
			return;
		}

		String fileName = unit.getPdfUrl(); // just the file name like "unit1.pdf"
		if (fileName != null && !fileName.isEmpty()) {
			// Full URL to the PDF
			String fullUrl = "http://10.135.241.21/c/Admin/uploads/" + fileName;

			Log.d("UnitClick", "Opening PDF URL: " + fullUrl);

			// Launch in browser
			Intent browserIntent = new Intent(Intent.ACTION_VIEW);
			browserIntent.setData(android.net.Uri.parse(fullUrl));
			startActivity(browserIntent);

		} else {
			Toast.makeText(this, "PDF file not available for this unit", Toast.LENGTH_SHORT).show();
		}
	}


}
