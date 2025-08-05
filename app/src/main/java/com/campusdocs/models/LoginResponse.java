package com.campusdocs.models;

import com.google.gson.annotations.SerializedName;

public class LoginResponse {
	@SerializedName("success")
	private boolean success;

	@SerializedName("user_id")
	private int userId;

	@SerializedName("full_name")
	private String fullName;

	@SerializedName("email")
	private String email;

	@SerializedName("message")
	private String message; // Optional: useful for showing errors

	public boolean isSuccess() {
		return success;
	}

	public int getUserId() {
		return userId;
	}

	public String getFull_name() {
		return fullName;
	}

	public String getEmail() {
		return email;
	}

	public String getMessage() {
		return message;
	}
}
