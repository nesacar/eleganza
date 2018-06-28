let baseUrl = '';
if(process.env.NODE_ENV === 'production'){
    baseUrl = 'http://eleganza.hr/';
}else{
    baseUrl = 'http://localhost/eleganza/public/';
    baseUrl = 'http://eleganza.hr/';
}

export const domain = baseUrl;
