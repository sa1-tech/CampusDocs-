package com.campusdocs.utils;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;

import com.campusdocs.activities.LoginActivity;
import com.campusdocs.models.User;

public class SharedPrefManager {
	private static final String SHARED_PREF_NAME = "campusdocs_pref";
	private static final String KEY_ID = "key_id";
	private static final String KEY_NAME = "key_full_name";
	private static final String KEY_EMAIL = "key_email";
	private static SharedPrefManager mInstance;
	private static Context mCtx;

	private SharedPrefManager(Context context) {
		mCtx = context;
	}

	public static synchronized SharedPrefManager getInstance(Context context) {
		if (mInstance == null) {
			mInstance = new SharedPrefManager(context);
		}
		return mInstance;
	}

	public void saveUserData(User user) {
		SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
		SharedPreferences.Editor editor = sharedPreferences.edit();
		editor.putInt(KEY_ID, user.getId());
		editor.putString(KEY_NAME, user.getFull_name());
		editor.putString(KEY_EMAIL, user.getEmail());
		editor.apply();
	}

	public boolean isLoggedIn() {
		SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
		return sharedPreferences.getString(KEY_EMAIL, null) != null;
	}

	public User getUser() {
		SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
		User user = new User();
		user.setId(sharedPreferences.getInt(KEY_ID, -1));
		user.setFull_name(sharedPreferences.getString(KEY_NAME, null));
		user.setEmail(sharedPreferences.getString(KEY_EMAIL, null));
		return user;
	}

	public void logout() {
		SharedPreferences sharedPreferences = mCtx.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
		SharedPreferences.Editor editor = sharedPreferences.edit();
		editor.clear();
		editor.apply();

		Intent intent = new Intent(mCtx, LoginActivity.class);
		intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
		mCtx.startActivity(intent);
	}
}
