# 以学院为单位进行划分

In [1]:

```
import pandas as pd
```

```
import numpy as np
```

## 导入学生手册考试成绩数据

In [2]:

```
df = pd.read_excel("学生手册考试成绩.xlsx")
```

## 预处理成绩数据dtype

In [3]:

```
df['总成绩'].replace('缺考','-1',inplace=True)
```

In [4]:

```
df[u'总成绩']=df[u'总成绩'].astype('int64')
```

## 创建学院信息

In [5]:

```
data = np.array(['法政与公共管理学院','国际文化交流学院', '化学与材料科学学院', '教育学院' , 
```

```
                 '历史文化学院','旅游系','马克思主义学院','美术与设计学院','软件学院','商学院',
```

```
                 '生命科学学院','数学与信息科学学院','体育学院','外国语学院','文学院','物理科学与信息工程学院',
```

```
                 '新闻传播学院','信息技术学院','音乐学院','职业技术学院','中燃工学院','资源与环境科学学院'])
```

In [6]:

```
college = pd.Series(data)
```

In [7]:

```
H = pd.DataFrame(np.random.randn(22,8),columns=["学院名称",'总人数','通过人数','80分以上','75分以上','未通过人数','及格率','优秀率'])
```

## 生成22个学院的成绩表

In [8]:

```
for i in range(0,22):
```

```
    m = df.loc[(df['学院名称'] == college[i]), ['姓名', '学号', '学院名称', '班级', '总成绩', '认证状态']]
```

```
    a=m.loc[(df['总成绩'] >= 80)].count()[0]
```

```
    b=m.loc[(df['总成绩'] >= 75)].count()[0]
```

```
    c=m.loc[(df['总成绩'] >= 70)].count()[0]
```

```
    d=m.count()[0]
```

```
    e=format(float(a)/float(d),'.3f')
```

```
    g=format(float(c)/float(d),'.3f')
```

```
    h=d-c
```

```
    H.loc[i]=[college[i],d,c,a,b,h,g,e]
```

```
    m.reset_index(drop = True)#重建索引
```

```
    #m.to_excel(college[i]+".xlsx", sheet_name='学生手册考试成绩')
```

In [9]:

```
H.to_excel("学院分析.xlsx", sheet_name='学生手册考试成绩')
```