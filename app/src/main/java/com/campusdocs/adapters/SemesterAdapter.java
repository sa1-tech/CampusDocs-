package com.campusdocs.adapters;

import android.content.Context;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.campusdocs.R;
import com.campusdocs.models.Semester;

import java.util.List;

public class SemesterAdapter extends ArrayAdapter<Semester> {

	private final LayoutInflater inflater;

	public SemesterAdapter(Context context, int resource, List<Semester> semesters) {
		super(context, resource, semesters);
		inflater = LayoutInflater.from(context);
	}

	@Override
	public boolean isEnabled(int position) {
		// Disable the first item (placeholder: "Select Semester")
		return position != 0;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		return createCustomView(position, convertView, parent);
	}

	@Override
	public View getDropDownView(int position, View convertView, ViewGroup parent) {
		return createCustomView(position, convertView, parent);
	}

	private View createCustomView(int position, View convertView, ViewGroup parent) {
		ViewHolder holder;
		if (convertView == null) {
			convertView = inflater.inflate(R.layout.item_semester, parent, false);
			holder = new ViewHolder();
			holder.textSemesterName = convertView.findViewById(R.id.textSemesterName);
			convertView.setTag(holder);
		} else {
			holder = (ViewHolder) convertView.getTag();
		}

		Semester semester = getItem(position);
		if (semester != null) {
			holder.textSemesterName.setText(semester.getName());

			// If it's the placeholder, gray it out
			if (position == 0) {
				holder.textSemesterName.setTextColor(Color.GRAY);
			} else {
				holder.textSemesterName.setTextColor(Color.BLACK);
			}
		}

		return convertView;
	}

	private static class ViewHolder {
		TextView textSemesterName;
	}
}
