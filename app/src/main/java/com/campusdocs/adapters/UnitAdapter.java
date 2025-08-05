package com.campusdocs.adapters;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.campusdocs.R;
import com.campusdocs.models.Unit;

import java.util.List;

public class UnitAdapter extends RecyclerView.Adapter<UnitAdapter.UnitViewHolder> {

	private List<Unit> unitList;
	private OnUnitClickListener listener;

	public UnitAdapter(List<Unit> unitList, OnUnitClickListener listener) {
		this.unitList = unitList;
		this.listener = listener;
	}

	@NonNull
	@Override
	public UnitViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
		View view = LayoutInflater.from(parent.getContext())
				.inflate(R.layout.item_unit, parent, false);
		return new UnitViewHolder(view);
	}

	@Override
	public void onBindViewHolder(@NonNull UnitViewHolder holder, int position) {
		Unit unit = unitList.get(position);
		holder.tvUnitTitle.setText(unit.getTitle());
		holder.tvUnitDescription.setText("PDF File: " + unit.getPdfUrl()); // Optional: Customize

		holder.itemView.setOnClickListener(v -> listener.onUnitClick(unit));
	}

	@Override
	public int getItemCount() {
		return unitList.size();
	}

	public interface OnUnitClickListener {
		void onUnitClick(Unit unit);
	}

	static class UnitViewHolder extends RecyclerView.ViewHolder {
		TextView tvUnitTitle, tvUnitDescription;

		UnitViewHolder(@NonNull View itemView) {
			super(itemView);
			tvUnitTitle = itemView.findViewById(R.id.tvUnitTitle);
			tvUnitDescription = itemView.findViewById(R.id.tvUnitDescription);
		}
	}
}
