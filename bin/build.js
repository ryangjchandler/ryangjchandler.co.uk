const { build } = require('esbuild')
const glob = require('tiny-glob')

const builder = async function () {
    const rootFiles = await glob('resources/js/*.js', {
        cwd: __dirname + '/../',
    })

    const componentFiles = await glob('resources/js/components/*.js', {
        cwd: __dirname + '/../'
    })

    const buildOptions = {
        stdio: 'inherit',
        minify: true,
        absolute: true,
    }

    build(Object.assign(buildOptions, {
        entryPoints: rootFiles,
        outdir: __dirname + '/../public/js',
    }))

    if (componentFiles.length > 0) {
        build(Object.assign(buildOptions, {
            entryPoints: componentFiles,
            outdir: __dirname + '/../public/js/components',
        }))
    }
}

builder()
