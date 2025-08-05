pluginManagement {
    repositories {
        google()
        mavenCentral()
        jcenter() // ✅ Add JCenter here
        gradlePluginPortal()
        maven { setUrl("https://jitpack.io") }
    }
}

dependencyResolutionManagement {
    repositoriesMode.set(org.gradle.api.initialization.resolve.RepositoriesMode.FAIL_ON_PROJECT_REPOS)
    repositories {
        google()
        mavenCentral()
        jcenter() // ✅ Add JCenter here too
        maven { setUrl("https://jitpack.io") }
    }
}

rootProject.name = "CampusDocs"
include(":app")
