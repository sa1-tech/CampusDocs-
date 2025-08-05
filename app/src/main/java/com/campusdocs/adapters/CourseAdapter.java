package com.campusdocs.adapters;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.campusdocs.R;
import com.campusdocs.models.Course;

import java.util.List;

public class CourseAdapter extends RecyclerView.Adapter<CourseAdapter.CourseViewHolder> {

	private List<Course> courseList;
	private OnCourseClickListener listener;

	public CourseAdapter(List<Course> courseList, OnCourseClickListener listener) {
		this.courseList = courseList;
		this.listener = listener;
	}

	@NonNull
	@Override
	public CourseViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
		View view = LayoutInflater.from(parent.getContext())
				.inflate(R.layout.item_course, parent, false);
		return new CourseViewHolder(view);
	}

	@Override
	public void onBindViewHolder(@NonNull CourseViewHolder holder, int position) {
		Course course = courseList.get(position);
		holder.textCourseName.setText(course.getName());

		// Optional: show number of semesters if you added it to the layout
		if (course.getSemesters() != null && !course.getSemesters().isEmpty()) {
			holder.textSemesterCount.setText("Semesters: " + course.getSemesters().size());
			holder.textSemesterCount.setVisibility(View.VISIBLE);
		} else {
			holder.textSemesterCount.setVisibility(View.GONE);
		}

		holder.itemView.setOnClickListener(v -> listener.onCourseClick(course));
	}

	@Override
	public int getItemCount() {
		return courseList.size();
	}

	public interface OnCourseClickListener {
		void onCourseClick(Course course);
	}

	static class CourseViewHolder extends RecyclerView.ViewHolder {
		TextView textCourseName;
		TextView textSemesterCount; // Optional

		CourseViewHolder(@NonNull View itemView) {
			super(itemView);
			textCourseName = itemView.findViewById(R.id.textCourseName);
			textSemesterCount = itemView.findViewById(R.id.textSemesterCount); // Must exist in item_course.xml
		}
	}
}
