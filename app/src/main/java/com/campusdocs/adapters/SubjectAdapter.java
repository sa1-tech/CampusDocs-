package com.campusdocs.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.campusdocs.R;
import com.campusdocs.models.Subject;

import java.util.List;

public class SubjectAdapter extends ArrayAdapter<Subject> {
	private final LayoutInflater inflater;
	private final int resource;

	public SubjectAdapter(Context context, int resource, List<Subject> subjects) {
		super(context, resource, subjects);
		this.inflater = LayoutInflater.from(context);
		this.resource = resource;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		Subject subject = getItem(position);
		View view = convertView;

		if (view == null) {
			view = inflater.inflate(resource, parent, false);
		}

		TextView textView = view.findViewById(R.id.txtSubjectName);
		if (subject != null) {
			textView.setText(subject.getName());
		}

		return view;
	}
}
