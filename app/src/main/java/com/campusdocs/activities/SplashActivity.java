package com.campusdocs.activities;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;

import androidx.appcompat.app.AppCompatActivity;

import com.campusdocs.R;
import com.campusdocs.utils.SharedPrefManager;

public class SplashActivity extends AppCompatActivity {
	private static final int SPLASH_TIME_OUT = 1500; // Slightly longer for better user experience

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_splash);

		new Handler().postDelayed(() -> {
			if (SharedPrefManager.getInstance(SplashActivity.this).isLoggedIn()) {
				startActivity(new Intent(SplashActivity.this, MainActivity.class));
			} else {
				startActivity(new Intent(SplashActivity.this, LoginActivity.class));
			}
			finish(); // Prevent going back to splash
		}, SPLASH_TIME_OUT);
	}
}
