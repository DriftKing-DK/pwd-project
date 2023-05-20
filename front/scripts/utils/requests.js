export function post_request(endpoint, post_data, token = null)
{

    const url = "http://localhost:12221" + endpoint;
    let xhr = new XMLHttpRequest()

    xhr.open('POST', url, true)
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
    if (token)
    {
        // Add the token to the header
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);

    }
    xhr.send(post_data);

    return xhr;
}

export function get_request(endpoint, token = null)
{
    const url = "http://localhost:12221" + endpoint;
    let xhr = new XMLHttpRequest()
    xhr.open('GET', url, true)
    if (token)
    {
        // Add the token to the header
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);

    }
    xhr.send();
    return xhr;
}