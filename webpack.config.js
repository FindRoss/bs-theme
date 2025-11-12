// webpack.config.js at project root
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
  ...defaultConfig,
  plugins: defaultConfig.plugins.filter(
    (p) => p?.constructor?.name !== 'RtlCssPlugin'
  ),
};
