package com.campusdocs.activities;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.campusdocs.R;
import com.campusdocs.models.LoginResponse;
import com.campusdocs.models.RegisterRequest;
import com.campusdocs.network.ApiClient;
import com.campusdocs.network.ApiService;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class RegisterActivity extends AppCompatActivity {

	private EditText edtName, edtEmail, edtPassword;
	private Button btnRegister;
	private ApiService apiService;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_register);

		edtName = findViewById(R.id.edtName);
		edtEmail = findViewById(R.id.edtEmail);
		edtPassword = findViewById(R.id.edtPassword);
		btnRegister = findViewById(R.id.btnRegister);

		apiService = ApiClient.getRetrofitInstance().create(ApiService.class);

		btnRegister.setOnClickListener(v -> registerUser());
	}

	private void registerUser() {
		String name = edtName.getText().toString().trim();
		String email = edtEmail.getText().toString().trim();
		String password = edtPassword.getText().toString().trim();

		if (name.isEmpty() || email.isEmpty() || password.isEmpty()) {
			Toast.makeText(this, "All fields are required", Toast.LENGTH_SHORT).show();
			return;
		}

		RegisterRequest request = new RegisterRequest(name, email, password);

		apiService.registerUser(request).enqueue(new Callback<LoginResponse>() {
			@Override
			public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
				if (response.isSuccessful() && response.body() != null && response.body().isSuccess()) {
					Toast.makeText(RegisterActivity.this, "Registration successful", Toast.LENGTH_SHORT).show();
					startActivity(new Intent(RegisterActivity.this, LoginActivity.class));
					finish();
				} else {
					Toast.makeText(RegisterActivity.this, "Registration failed", Toast.LENGTH_SHORT).show();
				}
			}

			@Override
			public void onFailure(Call<LoginResponse> call, Throwable t) {
				Toast.makeText(RegisterActivity.this, "Error: " + t.getMessage(), Toast.LENGTH_SHORT).show();
			}
		});
	}

}


