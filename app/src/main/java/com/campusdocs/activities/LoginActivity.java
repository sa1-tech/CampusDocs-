package com.campusdocs.activities;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.campusdocs.R;
import com.campusdocs.models.LoginRequest;
import com.campusdocs.models.LoginResponse;
import com.campusdocs.models.User;
import com.campusdocs.network.ApiClient;
import com.campusdocs.network.ApiService;
import com.campusdocs.utils.SharedPrefManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LoginActivity extends AppCompatActivity {

	private EditText edtEmail, edtPassword;
	private Button btnLogin, btnRegister;
	private ApiService apiService;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);

		edtEmail = findViewById(R.id.edtEmail);
		edtPassword = findViewById(R.id.edtPassword);
		btnLogin = findViewById(R.id.btnLogin);
		btnRegister = findViewById(R.id.btnRegister);

		apiService = ApiClient.getRetrofitInstance().create(ApiService.class);

		btnLogin.setOnClickListener(v -> loginUser());

		btnRegister.setOnClickListener(v ->
				startActivity(new Intent(LoginActivity.this, RegisterActivity.class))
		);
	}

	private void loginUser() {
		String email = edtEmail.getText().toString().trim();
		String password = edtPassword.getText().toString().trim();

		if (email.isEmpty() || password.isEmpty()) {
			Toast.makeText(this, "All fields are required", Toast.LENGTH_SHORT).show();
			return;
		}

		LoginRequest request = new LoginRequest(email, password);

		apiService.loginUser(request).enqueue(new Callback<LoginResponse>() {
			@Override
			public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
				if (response.isSuccessful() && response.body() != null) {
					if (response.body().isSuccess()) {
						// Successful login
						User user = new User(
								response.body().getUserId(),
								response.body().getFull_name(),
								response.body().getEmail()
						);
						SharedPrefManager.getInstance(LoginActivity.this).saveUserData(user);
						Toast.makeText(LoginActivity.this, "Login Successful", Toast.LENGTH_SHORT).show();
						startActivity(new Intent(LoginActivity.this, MainActivity.class));
						finish();
					} else {
						// Backend returned success=false: handle specific message
						String message = response.body().getMessage();
						if (message != null && message.equalsIgnoreCase("User not registered")) {
							Toast.makeText(LoginActivity.this, "User not registered. Please register first.", Toast.LENGTH_LONG).show();
						} else {
							Toast.makeText(LoginActivity.this, "Invalid credentials", Toast.LENGTH_SHORT).show();
						}
					}
				} else {
					Toast.makeText(LoginActivity.this, "Login failed. Please try again.", Toast.LENGTH_SHORT).show();
				}
			}

			@Override
			public void onFailure(Call<LoginResponse> call, Throwable t) {
				Toast.makeText(LoginActivity.this, "Login failed: " + t.getMessage(), Toast.LENGTH_LONG).show();
			}
		});
	}

}
