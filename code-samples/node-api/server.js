const http = require('node:http');

const initialTasks = [
  { id: 1, title: 'Write documentation', completed: false },
];

function createHandler() {
  const tasks = initialTasks.map(task => ({ ...task }));
  let nextId = 2;

  return async function handler(req, res) {
    const reply = (status, data) => {
      res.writeHead(status, { 'Content-Type': 'application/json; charset=utf-8' });
      res.end(JSON.stringify(data));
    };

    if (req.url === '/health' && req.method === 'GET') {
      return reply(200, { status: 'ok' });
    }
    if (req.url === '/tasks' && req.method === 'GET') {
      return reply(200, tasks);
    }
    if (req.url === '/tasks' && req.method === 'POST') {
      let raw = '';
      for await (const chunk of req) {
        raw += chunk.toString();
        if (raw.length > 4096) return reply(413, { error: 'Payload too large' });
      }

      let payload;
      try { payload = JSON.parse(raw); } catch { return reply(400, { error: 'Invalid JSON' }); }
      if (!payload || typeof payload.title !== 'string' || !payload.title.trim() || payload.title.length > 120) {
        return reply(400, { error: 'Valid title required (1–120 characters)' });
      }

      const task = { id: nextId++, title: payload.title.trim(), completed: false };
      tasks.push(task);
      return reply(201, task);
    }
    return reply(404, { error: 'Not found' });
  };
}

if (require.main === module) {
  const port = Number(process.env.PORT || 3000);
  http.createServer(createHandler()).listen(port, '127.0.0.1', () => {
    console.log(`API listening on http://127.0.0.1:${port}`);
  });
}

module.exports = { createHandler };
