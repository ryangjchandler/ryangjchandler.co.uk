#!/usr/bin/env node
const { writeFileSync } = require('fs')
const { resolve } = require('path')

const isProduction = process.env.NODE_ENV || 'development'
const path = resolve(__dirname + '/../public/mix-manifest.json')

let manifest = {
    '/css/app.css': '/css/app.css',
    '/js/index.js': '/js/index.js',
}

if (isProduction) {
    manifest['/css/app.css'] += `?${Math.random().toString(36).substr(2, 5)}`
    manifest['/js/index.js'] += `?${Math.random().toString(36).substr(2, 5)}`
}

writeFileSync(path, JSON.stringify(manifest, null, 4), err => {
    if (err) console.error(err)

    console.log('Successfully created mix-manifest.json')
})
