namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class FK : DbMigration
    {
        public override void Up()
        {
            DropPrimaryKey("dbo.Garages");
            AddColumn("dbo.Booking", "GarageName", c => c.String(nullable: false, maxLength: 128));
            AddColumn("dbo.Garages", "GarageName", c => c.String(nullable: false, maxLength: 128));
            AddPrimaryKey("dbo.Garages", "GarageName");
            CreateIndex("dbo.Booking", "GarageName");
            AddForeignKey("dbo.Booking", "GarageName", "dbo.Garages", "GarageName", cascadeDelete: true);
            DropColumn("dbo.Booking", "Garage");
            DropColumn("dbo.Garages", "Id");
            DropColumn("dbo.Garages", "Name");
        }
        
        public override void Down()
        {
            AddColumn("dbo.Garages", "Name", c => c.String(nullable: false));
            AddColumn("dbo.Garages", "Id", c => c.Int(nullable: false, identity: true));
            AddColumn("dbo.Booking", "Garage", c => c.String(nullable: false));
            DropForeignKey("dbo.Booking", "GarageName", "dbo.Garages");
            DropIndex("dbo.Booking", new[] { "GarageName" });
            DropPrimaryKey("dbo.Garages");
            DropColumn("dbo.Garages", "GarageName");
            DropColumn("dbo.Booking", "GarageName");
            AddPrimaryKey("dbo.Garages", "Id");
        }
    }
}
