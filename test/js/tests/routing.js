test('api definition', function() {
  expect(6);

  ok(Routing, 'Routing is defined');
  ok($.isFunction(Routing.connect), 'Routing.connect is a function');
  ok($.isFunction(Routing.generate), 'Routing.generate is a function');
  ok($.isFunction(Routing.get), 'Routing.get is a function');
  ok($.isFunction(Routing.has), 'Routing.has is a function');
  ok($.isFunction(Routing.flush), 'Routing.flush is a function');
});

test('route registration', function() {
  expect(9);

  Routing.flush();
  strictEqual(Routing.connect('route_1', '/route1'), Routing,
              'connect "route_1". Routing.connect returns Routing');
  ok(Routing.has('route_1'), 'route_1 is connected');
  ok(!Routing.has('route_2'), 'route_2 is not yet connected');
  equal(Routing.get('route_1'), '/route1', 'route_1 url is correct');

  strictEqual(Routing.connect('route_2', '/route2'), Routing,
              'connect "route_2". Routing.connect returns Routing');
  ok(Routing.has('route_1'), 'route_1 is still connected');
  ok(Routing.has('route_2'), 'route_2 is connected');
  equal(Routing.get('route_1'), '/route1', 'route_1 url is still correct');
  equal(Routing.get('route_2'), '/route2', 'route_2 url is correct');
});

test('route generation', function() {
  expect(14);

  Routing.flush();
  equal(Routing.connect('route_1', '/route1').generate('route_1'), '/route1',
                              'generating url without parameters returns url');

  equal(Routing.generate('route_1', { foo: 'bar' }), '/route1?foo=bar',
                        'passing extra parameters happens it as query string');

  equal(Routing.connect('route_2', '/route2?a=b')
                              .generate('route_2', { foo: 'bar' }),
                              '/route2?a=b&foo=bar',
                              'query string is extended if already started');

  equal(Routing.connect('route_3', '/route3.:sf_format')
                              .generate('route_3', {sf_format: 'html'}), '/route3.html',
                              '. is a separator');

  equal(Routing.connect('route_4', '/route/:id/edit')
                              .generate('route_4', { id: 'bar' }),
                              '/route/bar/edit',
                              'basic parameter replacement is ok');

  equal(Routing.connect('route_5', '/route/:id')
                              .generate('route_5', { id: 'bar' }),
                              '/route/bar',
                              'end of string parameter replacement is ok');

  equal(Routing.generate('route_5', { id: 'foo', foo: 'bar' }),
                              '/route/foo?foo=bar',
                        'passing extra parameters happens it as query string');

  equal(Routing.connect('route_6', '/route/:identical/id/:id/id/:identical/foo')
                              .generate('route_6', { id: 'bar' }),
                              '/route/:identical/id/bar/id/:identical/foo',
                              'only exact variable matches.');

  equal(Routing.connect('route_7', ':id')
                              .generate('route_7', { id: 'bar' }),
                              '/bar',
                              'replacement without separator is ok');

  // check for prefix
  Routing.prefix = '/baz/';
  equal(Routing.generate('route_7', { id: 'bar' }),
                              '/baz/bar',
                              'prefix is added');
  Routing.prefix = 'baz';
  equal(Routing.generate('route_7', { id: 'bar' }),
                              '/baz/bar',
                              'prefix is surrounded by slashes');

  // check for defaults
  Routing.defaults = {sf_format: 'html', 'foo': 'bar'};
  Routing.prefix = '';
  equal(Routing.generate('route_3'), '/route3.html', 
                                'defaults are taken in account');

  // check for route defaults
  equal(Routing.connect('route_8', '/route/:id.:sf_format', {'id': 'foo', 'sf_format': 'json'})
                              .generate('route_8'),
                              '/route/foo.json',
                              'route defaults override Routing defaults');

  equal(Routing.generate('route_8', { id: 'bar' }),
                              '/route/bar.json',
                              'route parameters overrides route defaults');
});
