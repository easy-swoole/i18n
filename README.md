# i18n
## 使用
```
use EasySwoole\I18N\AbstractDictionary;
use EasySwoole\I18N\I18N;
//定义一个词典。const值请务必于const变量名一致，这样是避免用户手敲词条名称出错
class Dictionary extends AbstractDictionary
{
    const HELLO = 'HELLO';
    const GOOD_MORNING = 'GOOD_MORNING';
    const HOME = 'HOME';

}
//定义一个语言包  
class Chinese extends Dictionary{
    const HELLO = '你好';
    const HOME = '主页';
}
//定义一个语言包  
class English extends Dictionary
{
    const HELLO = 'hello';
    const GOOD_MORNING = 'Hi,good morning';
    const HOME = 'home page';
}
//注册语言包
I18N::getInstance()->addLanguage(new Chinese(),'Cn');
I18N::getInstance()->addLanguage(new English(),'En');
//设置默认语言包
I18N::getInstance()->setDefaultLanguage('Cn');
//使用
$ret = I18N::getInstance()->translate(Dictionary::HELLO);
var_dump($ret);//你好
$ret = I18N::getInstance()->translate(Dictionary::GOOD_MORNING);
var_dump($ret);//GOOD_MORNING
$ret = I18N::getInstance()->sprintf('%s ! 欢迎到 %s !!!!',Dictionary::HELLO,Dictionary::HOME);
var_dump($ret);//"你好 ! 欢迎到 主页 !!!!
$ret = I18N::getInstance()->setLanguage('En')->translate(Dictionary::GOOD_MORNING);
var_dump($ret);//Hi,good morning

```