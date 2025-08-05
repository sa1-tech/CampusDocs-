package com.campusdocs.utils;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.webkit.MimeTypeMap;
import android.widget.Toast;

import androidx.core.content.FileProvider;

import java.io.File;

public class PdfUtils {

	public static void openPdf(Context context, String pdfUrl) {
		try {
			if (pdfUrl.startsWith("http://") || pdfUrl.startsWith("https://")) {
				// Open remote PDF using WebView/PDF.js or suggest download
				Toast.makeText(context, "Remote PDF - open via in-app viewer", Toast.LENGTH_SHORT).show();
				// Optionally: launch PdfViewerActivity
                /*
                Intent intent = new Intent(context, PdfViewerActivity.class);
                intent.putExtra("pdfFileName", pdfUrl);
                context.startActivity(intent);
                */
				return;
			}

			File file = new File(pdfUrl);
			Uri uri = FileProvider.getUriForFile(
					context,
					context.getPackageName() + ".provider",
					file
			);

			String mime = MimeTypeMap.getSingleton().getMimeTypeFromExtension("pdf");

			Intent intent = new Intent(Intent.ACTION_VIEW);
			intent.setDataAndType(uri, mime);
			intent.addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION);
			context.startActivity(intent);

		} catch (Exception e) {
			Toast.makeText(context, "No application found to open PDF", Toast.LENGTH_SHORT).show();
		}
	}
}
