export function apiJoin(path) {
  return process.env.API_SERVER + path;
}

export function uploadsJoin(path) {
  return process.env.UPLOADS_SERVER + path;
}
