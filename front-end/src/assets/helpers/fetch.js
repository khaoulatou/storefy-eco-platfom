const mainUrl = 'http://127.0.0.1:8000/api/v1/';
export default async (endpoint, body = null, method, Authenticated = false) => {
  let requestOptions;
  if (Authenticated) {
    const headers = new Headers();
    headers.append('Connection', 'keep-alive');
    headers.append('Authorization', `Bearer ${localStorage.getItem('token')}`);
    requestOptions = {
      method,
      headers,
      redirect: 'follow',
    };
  } else {
    requestOptions = {
      method,
      redirect: 'follow',
    };
  }
  if (body) (requestOptions.body = body);
  const request = await fetch(`${mainUrl}${endpoint}`, requestOptions);
  return [await request.json(), request.status];
};