const test = require('node:test');
const assert = require('node:assert/strict');
const http = require('node:http');
const { createHandler } = require('./server');

test('task API: list, validate, create', async () => {
  const server = http.createServer(createHandler());
  await new Promise(resolve => server.listen(0, '127.0.0.1', resolve));
  const base = `http://127.0.0.1:${server.address().port}`;
  try {
    const get = await fetch(base + '/tasks');
    assert.equal(get.status, 200);
    assert.equal((await get.json()).length, 1);

    const invalid = await fetch(base + '/tasks', {
      method: 'POST', headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ title: '' }),
    });
    assert.equal(invalid.status, 400);

    const created = await fetch(base + '/tasks', {
      method: 'POST', headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ title: 'Review tests' }),
    });
    assert.equal(created.status, 201);
    assert.equal((await created.json()).id, 2);

    const listed = await fetch(base + '/tasks');
    assert.equal((await listed.json()).length, 2);
  } finally {
    await new Promise((resolve, reject) => server.close(error => error ? reject(error) : resolve()));
  }
});
