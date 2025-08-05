package com.campusdocs.models;

import com.google.gson.annotations.SerializedName;

public class Unit {

	private int id;

	@SerializedName("unit_name")
	private String title;

	@SerializedName("subject_id")
	private int subjectId;

	@SerializedName("pdf_url")
	private String pdfUrl;

	public Unit(int id, String title, int subjectId, String pdfUrl) {
		this.id = id;
		this.title = title;
		this.subjectId = subjectId;
		this.pdfUrl = pdfUrl;
	}

	public int getId() {
		return id;
	}

	public String getTitle() {
		return title;
	}

	public int getSubjectId() {
		return subjectId;
	}

	public String getPdfUrl() {
		return pdfUrl;
	}
}
