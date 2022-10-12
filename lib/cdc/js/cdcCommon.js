
function dateFormat(date){
    let month = date.getMonth() + 1;
    let day = date.getDate();
    let hour = date.getHours();
    let minute = date.getMinutes();
    let second = date.getSeconds();

    month = month >= 10 ? month : '0' + month;
    day = day >= 10 ? day : '0' + day;
    hour = hour >= 10 ? hour : '0' + hour;
    minute = minute >= 10 ? minute : '0' + minute;
    second = second >= 10 ? second : '0' + second;
    return date.getFullYear() + "-" + month + "-" + day + "-" + hour + ":" + minute + ":" + second;
}

function convertVideoUrl(url){
    // 유튜브 동영상 
    const youtubeUrl = /(http:|https:)?(\/\/)?(www\.)?(youtube.com|youtu.be)\/(watch|embed)?(\?v=|\/)?(\S+)?/g;
    // 네이버 TV
    const naverTvUrl = /(http:|https:)?(\/\/)?(www\.)?(tv.naver.com|m.tv.naver.com)\/(\?v=|\/)?(\S+)?/g;

    if(url.match(youtubeUrl)){
        const parseUrl = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        const match = url.match(parseUrl);
        const id = match[match.length - 1];
        url = `https://youtube.com/embed/${id}`
    } else if (url.match(naverTvUrl)){
         // 네이버 TV
        url = url.replace('/v/', '/embed/');
    } else {
        url = '';
    }
    return url;
}

// 영상(파일 업로드) URL
function fileLoadVideoUrl(file){
    return URL.createObjectURL(file);
}

async function setConverFile(fileInfo){
    const fileSource = fileInfo.source;
    if(!fileSource) return;
    const filePath = fileInfo.path;
    const fileName = fileInfo.file;
    const fileSrc = `${filePath}/${fileName}`;
    const response = await fetch(fileSrc);

    const data = await response.blob();
    const ext = fileSrc.split(".").pop();
    const type = fileName.endsWith(".mp4") ? 'video' : 'image'
    const metadata = { type: `${type}/${ext}` };
    const file = new File([data], fileName, metadata);
    
    return file;
}

function clickToAction(wr_cat_link) {
    const httpPatten = /(http(s)?:\/\/)([a-z0-9\w]+\.*)+[a-z0-9]{2,4}/gi;
    let actionUrl = wr_cat_link;
    console.log(actionUrl);
    if (!actionUrl.match(httpPatten) || actionUrl.startsWith('data')) {
        actionUrl = `http://${actionUrl}`
    }
    window.open(actionUrl);
}
