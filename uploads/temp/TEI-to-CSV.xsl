<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:tei="http://www.tei-c.org/ns/1.0"
    exclude-result-prefixes="tei"
    version="2.0">

<xsl:output method="text" omit-xml-declaration="yes" indent="no"/>
<xsl:template match="/">
    <xsl:text>"Title","Description","Creator","Source","Publisher","Date","Contributor","Rights","Relation","Identifier","Language","Type", "XML","Image 1","Image 2","Image 3","Image 4","Image 5","Image 6","Image 7","Image 8"&#10;</xsl:text>
    <xsl:variable name="teiFiles" select="collection('./?select=*.xml')"/>
    <xsl:for-each select="$teiFiles">
        <xsl:text>"</xsl:text><xsl:value-of select="//tei:titleStmt/tei:title" /><xsl:text>","</xsl:text>
        <xsl:text>Kirjoituspaikka: </xsl:text><xsl:value-of select="//tei:opener/tei:dateline/tei:placeName" /><xsl:text>","</xsl:text>
        <xsl:value-of select="//tei:msContents/tei:msItem/tei:author/tei:surname" /><xsl:text>, </xsl:text>
        <xsl:value-of select="//tei:msContents/tei:msItem/tei:author/tei:forename" /><xsl:text>","</xsl:text>
        <xsl:value-of select="//tei:msIdentifier/tei:repository" /><xsl:text>","</xsl:text>
        <xsl:text>Suomalaisen Kirjallisuuden Seura","</xsl:text>
        <xsl:value-of select="//tei:opener/tei:dateline/tei:date/@when" /><xsl:text>","</xsl:text>
        <xsl:text>Suomalaisen Kirjallisuuden Seura","</xsl:text>
        <xsl:text>Suomalaisen Kirjallisuuden Seura","</xsl:text>
        <xsl:value-of select="//tei:sourceDesc/tei:msDesc/tei:msIdentifier/tei:idno" /><xsl:text>","</xsl:text>
        <xsl:value-of select="//tei:bibl" /><xsl:text>","</xsl:text>
        <xsl:value-of select="//tei:profileDesc/tei:langUsage/tei:language" /><xsl:text>","</xsl:text>
        <xsl:value-of select="//tei:div/@type" /><xsl:text>","</xsl:text>
        <xsl:text>http://localhost/uploads/</xsl:text><xsl:value-of select="tokenize(base-uri(), '/')[last()]" /><xsl:text>",</xsl:text>
        <xsl:for-each select="distinct-values(//tei:pb/@facs)">
          <xsl:text>"http://localhost/uploads/</xsl:text><xsl:value-of select="current()" /><xsl:text>_f.jpg",</xsl:text>
        </xsl:for-each>
        <xsl:text>&#10;</xsl:text>
    </xsl:for-each>
</xsl:template>
</xsl:stylesheet>
