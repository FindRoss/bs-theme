// webpack.config.js at project root
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
  ...defaultConfig,
  output: {
    ...defaultConfig.output,
    clean: false,
  },
  plugins: defaultConfig.plugins.filter(
    (p) => p?.constructor?.name !== 'RtlCssPlugin'
  ),
};
