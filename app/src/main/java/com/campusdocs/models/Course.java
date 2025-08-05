package com.campusdocs.models;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class Course {
	private int id;
	private String name;

	@SerializedName("semesters")
	private List<Semester> semesters;

	public int getId() {
		return id;
	}

	public String getName() {
		return name;
	}

	public List<Semester> getSemesters() {
		return semesters;
	}
}

