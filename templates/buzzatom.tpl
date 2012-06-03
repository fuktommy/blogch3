{strip}
{* <?xml version="1.0" encoding="UTF-8" ?> *}
<feed xmlns:crosspost='http://purl.org/syndication/cross-posting' {* *}
      xmlns='http://www.w3.org/2005/Atom' {* *}
      xmlns:buzz='http://schemas.google.com/buzz/2010' {* *}
      xmlns:georss='http://www.georss.org/georss' {* *}
      xmlns:media='http://search.yahoo.com/mrss/' {* *}
      xmlns:gd='http://schemas.google.com/g/2005' {* *}
      xmlns:poco='http://portablecontacts.net/ns/1.0' {* *}
      xmlns:activity='http://activitystrea.ms/spec/1.0/' {* *}
      xmlns:thr='http://purl.org/syndication/thread/1.0'>
<entry gd:kind="buzz#activity">
    <title>{$entry.title|escape}</title>
    <published>{$entry.published|escape}</published>
    <updated>{$entry.updated|escape}</updated>
    <id>{$entry.id|escape}</id>
    <link href="{$entry.link|escape}" type="text/html" rel="alternate"/>
    <content type="html">{$entry.content|escape}</content>
    <activity:object>
        <activity:object-type>http://activitystrea.ms/schema/1.0/note</activity:object-type>
        {foreach from=$entry.links item="link"}
            <buzz:attachment>
                <activity:object-type>http://activitystrea.ms/schema/1.0/article</activity:object-type>
                <title>{$link.title|escape}</title>
                <link href="{$link.href|escape}" rel="alternate"/>
            </buzz:attachment>
        {/foreach}
        {foreach from=$entry.images item="image"}
            <buzz:attachment>
                <activity:object-type>http://activitystrea.ms/schema/1.0/photo</activity:object-type>
                <link rel="enclosure" type="image/jpeg" href="{$image.href|escape}" media:height="{$image.height|escape}" media:width="{$image.width|escape}"/>
                {if $image.preview}
                    <link rel="preview" type="image/jpeg" href="{$image.preview.href|escape}" media:height="{$image.preview.height|escape}" media:width="{$image.preview.width|escape}"/>
                {/if}
            </buzz:attachment>
        {/foreach}
    </activity:object>
    {if $entry.map}
        <georss:point>{$entry.map.lat|escape} {$entry.map.long|escape}</georss:point>
        <georss:featureName>{$entry.map.featureName|escape}</georss:featureName>
        <poco:address><poco:formatted>{$entry.map.formatted|escape}</poco:formatted></poco:address>
    {/if}
</entry>
</feed>
{/strip}
