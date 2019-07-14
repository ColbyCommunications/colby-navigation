const FixStyleOnlyEntriesPlugin = require( 'webpack-fix-style-only-entries' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const path = require( 'path' );

const css = () => {
    const plugins = [ new FixStyleOnlyEntriesPlugin(), new MiniCssExtractPlugin( '[name].css' ) ];

    return {
        plugins,
        entry: {
            'horizontal-header-nav': path.resolve( __dirname, 'assets/sass/horizontal-header-nav.scss' )
        },
        module: {
            rules: [
                {
                    test: /\.s?css$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        'postcss-loader',
                        'sass-loader',
                    ]
                }
            ]
        }
    }
};

module.exports = css;