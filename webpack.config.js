const path = require ("path");
const webpack = require("webpack"); // why do I need this? Do I?

module.exports = {
    entry: "./src/index.js",
    output: {
        filename: "./dist/main.js",
        path: path.join(__dirname, "dist")
    }
}