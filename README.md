Fancy Footnotes Plugin for WordPress
===============
This plugin was developed for use on [HardcoreWP.com](http://hardcorewp.com). It seems to work well on HardcoreWP but may not be robust on other blogs. However, we welcome feedback and pull requests.

##Usage
Fancy Footnotes provides no user interface; everything is done using shortcodes and shortcode-like markup.


###Footnote References
In your content simply add your footnote reference in the form `[^label]` where `label` is any word you choose to label your footnote reference and it's associated footnote. Note that these labels will be discarded by the plugin and your users will never seen them as long as the plugin remains activated.

For example, assuming you were adding footnotes to the [Jabberwocky](http://www.jabberwocky.com/carroll/jabber/jabberwocky.html):

~~~
Twas brillig, and the slithy toves[^tove]
  Did gyre and gimble in the wabe[^wabe]:
All mimsy were the borogoves[^borogove],
  And the mome raths outgrabe.
~~~

###Footnotes
You should put your footnotes in a `[footnotes]` shortcode at the end of your post using the following format:

~~~
[footnotes]
[^wabe]: Explain the long history of the Wabe.
[^borogove]: Talk briefly about the Borogove.
[^tove]: Provide minute details about Toves.
[/footnotes]
~~~

##Output
###Footnote References

Footnote references will be output using this HTML:
~~~
<a class="footnote-link" name="{$footnote_label}-reference" href="#{$footnote_label}-footnote">
  <sup>[{$number}]</sup>
</a>
~~~
So our Jabberwocky example will produce the following noting that they are numbered in the order the references are reached in the content:

~~~
Twas brillig, and the slithy toves<a class="footnote-link" name="tove-reference" href="#tove-footnote"><sup>[1]</sup></a>,
  Did gyre and gimble in the wabe<a class="footnote-link" name="wabe-reference" href="#wabe-footnote"><sup>[2]</sup></a>,
All mimsy were the borogoves<a class="footnote-link" name="borogove-reference" href="#borogove-footnote"><sup>[3]</sup></a>,
  And the mome raths outgrabe.
~~~

###Footnotes

Footnotes will be output using this HTML:
~~~
<div id="footnotes">
  <h2>Footnotes</h2>
  <dl>
  	{$footnote_html}
  </dl>
</div>
<div class="clear"></div>
~~~
The `$footnote_html` contains each of the `<dt><dd>` pairs where each uses the following HTML:
~~~
<dt><a class="footnote-link" name="{$footnote_label}-footnote" href="#{$footnote_label}-reference">[{$number}]</a></dt>
<dd>{$footnote_text}</dd>
~~~

Back again to our Jabberwocky example the footnotes for it would be the following noting they are numbered in order of the references, _not_ in order of the footnotes as written:

~~~
<div id="footnotes">
  <h2>Footnotes</h2>
  <dl>
	<dt><a class="footnote-link" name="tove-footnote" href="#tove-reference">[1]</a></dt>
	<dd>Provide minute details about Toves.</dd>
    <dt><a class="footnote-link" name="wabe-footnote" href="#wabe-reference">[2]</a></dt>
    <dd>Explain the long history of the Wabe.</dd>
    <dt><a class="footnote-link" name="borogove-footnote" href="#borogove-reference">[3]</a></dt>
    <dd>Talk briefly about the Borogove.</dd>
  </dl>
</div>
<div class="clear"></div>
~~~

##Shortcode Arguments
The `[footnotes]` shortcode currently accepts two (2) arguments that allows the user to specify the following: 

`head`
: The heading's HTML tag. Defaults to `'h2'`. 	

`class`
: The CSS class for the `<div>` wrapper. Defaults to `'footnotes'`.

The following example changes the heading tag to `'h3'` and the CSS class for the `<div>` to `'my-footnotes'`:
~~~
[footnotes head="h3" class="my-footnotes"]
[^wabe]: Explain the long history of the Wabe.
[^borogove]: Talk briefly about the Borogove.
[^tove]: Provide minute details about Toves.
[/footnotes]
~~~

##Feedback
Feedback if welcome! Make suggestions [here on GitHub](https://github.com/newclarity/fancy-footnotes/issues) or contact me at [my About.me page](http://about.me/mikeschinkel). 

##License
Fancy Footnotes Plugin for WordPress is licensed using GPL2+.
