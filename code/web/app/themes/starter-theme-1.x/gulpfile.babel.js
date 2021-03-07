import { series, watch, src, dest, task } from "gulp";
import cleanCSS from "gulp-clean-css";
import sourcemaps from "gulp-sourcemaps";
import sass from "gulp-sass";
import autoprefixer from "gulp-autoprefixer";
import concat from "gulp-concat";
import browserSync from "browser-sync";
import uglify from "gulp-uglify";

const siteUrl = 'http://localhost';
let sync = browserSync.create();
// define functions
function css() {
    return src("./src/styles/*css")
        .pipe(sourcemaps.init())
        .pipe(autoprefixer())
        .pipe(cleanCSS())
        .pipe(concat("all.min.css"))
        .pipe(sourcemaps.write())
        .pipe(dest("./"))
        .pipe(sync.stream());
}

function scss() {
    return src("./static/styles/*scss")
        .pipe(sass())
        .pipe(sourcemaps.init())
        .pipe(autoprefixer())
        .pipe(cleanCSS())
        .pipe(concat("all.min.css"))
        .pipe(sourcemaps.write())
        .pipe(dest("./"));
}

// function js() {
//     return src("./src/scripts/**/*js")
//         .pipe(concat("scripts.min.js"))
//         .pipe(
//             uglify({
//                 toplevel: true,
//             })
//         )
//         .pipe(dest("./build/js"))
//         .pipe(sync.stream());
// }


function watcher() {
    sync.init({
        proxy: {
            target: siteUrl,
            ws: true
        },
    });
    watch("./static/styles/**/*.scss", scss);
    // watch("./static/styles/**/*.css", css);
    // watch("./src/scripts/**/*.js", js);
    watch("./templates/**/*.twig").on("change", sync.reload);
}

// Expose helloworld series task
exports.default = watcher;