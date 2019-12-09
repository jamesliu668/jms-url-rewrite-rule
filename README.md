# JMS URL Rewrite Rule

It is a WordPress plugin which is also tracked in WordPress svn repository.
如果WordPress中已经存在了大量的Permalink，并且想要把Permalink修改为新的格式，可以使用本插件为所有已经存在的Permalink创建urlrewrite的规则。节省了我们一条一条手写的时间。

注意：
测试发现，对于WordPress来说，如果改变了Permalink的格式，应该是自动向后兼容的。仍然待确认。

## Keep SVN Pure

In git repository, please keep all files and folders, even empty folders, from svn repository, including `.svn`. To avoid adding git files to svn, please run following commands on MacOS:

```bash
export SVN_EDITOR=vi
svn propedit svn:ignore .
```

After opening the vi editor, please add following content. The content may vary according your real case.

```bash
.git
.gitignore
LICENSE
README.md
```

## Keep All SVN Files in Git

To keep 3 empty folders `assets`, `branches`, `tags` in git repository, please create an empty `.gitignore` file in each folder, as these 3 folders are highly likely empty for most of the WordPress plugin project. After creating the file, please run following commands to ignore this file in svn.

```bash
svn propset svn:ignore '.gitignore' assets
svn propset svn:ignore '.gitignore' branches
svn propset svn:ignore '.gitignore' tags
```

## SVN Help

`svn checkout url`
`svn status`
`svn commit`