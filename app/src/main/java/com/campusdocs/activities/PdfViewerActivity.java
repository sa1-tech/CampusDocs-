package com.campusdocs.activities;

import android.os.Bundle;
import android.util.Log;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.campusdocs.R;

public class PdfViewerActivity extends AppCompatActivity {

	private static final String BASE_PDF_URL = "http://10.135.241.21/c/Admin/uploads/";
	private WebView pdfWebView;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_pdf_viewer);

		pdfWebView = findViewById(R.id.pdfWebView);

		WebSettings webSettings = pdfWebView.getSettings();
		webSettings.setJavaScriptEnabled(true);
		webSettings.setBuiltInZoomControls(true);
		webSettings.setDisplayZoomControls(false);

		pdfWebView.setWebViewClient(new WebViewClient());

		String pdfFileName = getIntent().getStringExtra("pdfFileName");
		Log.d("PdfViewerActivity", "Received PDF file name: " + pdfFileName); // ✅ DEBUG

		if (pdfFileName == null || pdfFileName.isEmpty()) {
			Toast.makeText(this, "No PDF file provided", Toast.LENGTH_SHORT).show();
			finish();
			return;
		}

		String pdfUrl = BASE_PDF_URL + pdfFileName;
		String viewerUrl = "https://drive.google.com/viewerng/viewer?embedded=true&url=" + pdfUrl;

		pdfWebView.loadUrl(viewerUrl);
	}
}
