package com.campusdocs.models;

public class Semester {
	private int id;
	private int course_Id;
	private String name;

	public Semester() {
		// Default no-arg constructor for dummy item
	}

	public Semester(String name) {
		this.name = name;
	}

	public Semester(int id, String name) {
		this.id = id;
		this.name = name;
	}

	public Semester(int id, int course_Id, String name) {
		this.id = id;
		this.course_Id = course_Id;
		this.name = name;
	}

	// Getters and Setters
	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public int getCourse_Id() {
		return course_Id;
	}

	public void setCourse_Id(int course_Id) {
		this.course_Id = course_Id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}
}
