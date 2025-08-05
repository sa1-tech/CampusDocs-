package com.campusdocs.network;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class ApiClient {

	private static final String BASE_URL = "http://10.135.241.21/c/Admin/api/";

	private static Retrofit retrofit = null;

	public static Retrofit getRetrofitInstance() {
		if (retrofit == null) {
			retrofit = new Retrofit.Builder()
					.baseUrl(BASE_URL)
					.addConverterFactory(GsonConverterFactory.create())
					.build();
		}
		return retrofit;
	}
}
