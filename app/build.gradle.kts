plugins {
    alias(libs.plugins.android.application)
}

android {
    namespace = "com.campusdocs"
    compileSdk = 35

    defaultConfig {
        applicationId = "com.campusdocs"
        minSdk = 28
        targetSdk = 35
        versionCode = 1
        versionName = "1.0"

        testInstrumentationRunner = "androidx.test.runner.AndroidJUnitRunner"
    }

    buildTypes {
        release {
            isMinifyEnabled = false
            proguardFiles(
                getDefaultProguardFile("proguard-android-optimize.txt"),
                "proguard-rules.pro"
            )
        }
    }

    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_11
        targetCompatibility = JavaVersion.VERSION_11
    }
}

dependencies {
    implementation(libs.appcompat)
    implementation(libs.material)
    implementation(libs.activity)
    implementation(libs.constraintlayout)
    implementation("androidx.recyclerview:recyclerview:1.4.0")

    // ✅ Correct PDF Viewer dependency from JitPack (see JitPack version name)
//    implementation("com.github.barteksc:android-pdf-viewer:2.8.2")
//    implementation("com.github.mhiew:android-pdf-viewer:3.2.0-beta.3")
    // ✅ Fast Android Networking (JitPack structure)
    implementation("com.github.amitshekhariitbhu.Fast-Android-Networking:android-networking:1.0.4")

    implementation("com.squareup.retrofit2:retrofit:2.9.0")

    // Optional: Gson converter (if you're using JSON parsing)
    implementation("com.squareup.retrofit2:converter-gson:2.9.0")

    // Logging (optional but useful)
    implementation("com.squareup.okhttp3:logging-interceptor:4.12.0")
    implementation("androidx.core:core:1.13.0")
    implementation("com.google.android.material:material:1.10.0")
    // Testing
    testImplementation(libs.junit)
    androidTestImplementation(libs.ext.junit)
    androidTestImplementation(libs.espresso.core)
}




