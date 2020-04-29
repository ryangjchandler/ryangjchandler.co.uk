Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-storage-manager',
      path: '/nova-storage-manager',
      component: require('./components/Tool'),
    },
  ])
})
