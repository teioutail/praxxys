class Common
{
    strip_tags(str) {
        str = str.toString();
        return str.replace(/<\/?[^>]+>/gi, '');
    }
}


export default Common = new Common()