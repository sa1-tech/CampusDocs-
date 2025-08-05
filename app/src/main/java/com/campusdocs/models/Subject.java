package com.campusdocs.models;

public class Subject {
	private int id;
	private int semesterId;
	private String name;

	public Subject(int id, int semesterId, String name) {
		this.id = id;
		this.semesterId = semesterId;
		this.name = name;
	}

	public int getId() {
		return id;
	}

	public int getSemesterId() {
		return semesterId;
	}

	public String getName() {
		return name;
	}
}
